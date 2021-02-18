backtrackFC(Assignment) :-
    variables(Variables),                                                  % get the predefined variables
    forwardchecking(Variables,[],Assignment).                              % solve the problem and get an solution assignment

forwardchecking([],_,[]).
forwardchecking([X:DX|Variables],PartialAssignment,[(X,V)|Solution]) :-
    member(V,DX),                                                          % choose a value in the V's domain
    filter(X,V,Variables,FilteredVariables),                               % filter variables' domains
    forwardchecking(FilteredVariables,[(X,V)|PartialAssignment],Solution). % add the V's assignment to the partial one

filter(_,_,[],[]).
filter(Xi,Vi,[Xj:Dj|Variables],[Xj:FilteredDj|FilteredDomains]) :-
    bagof(Vj, (member(Vj,Dj),consistent((Xi,Vi),(Xj,Vj))), FilteredDj),    % get the values for variables sharing constraints
    FilteredDj \= [],                                                      % stop if no more values
    filter(Xi,Vi,Variables,FilteredDomains).                               % continue on next variables
